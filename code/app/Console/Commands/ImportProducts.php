<?php

namespace App\Console\Commands;

use App\Http\Resources\ProductResource;
use App\Models\ErrorLog;
use App\Models\ImportHistory;
use App\Models\Product;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products {--cron}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualizar/Inserir produtos no banco de dados.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo('Iniciando importação de produtos...');
        // Obtém a lista de atributos preenchíveis do modelo Product
        $product = new Product();
        $fillableAttributes = $product->getFillable();

        // URL que contém a lista de arquivos JSON
        $indexUrl = 'https://challenges.coode.sh/food/data/json/index.txt';

        // Obter a lista de arquivos do URL
        $response = Http::get($indexUrl);
        $fileList = array_filter(explode("\n", $response->body()));

        // Baixar cada arquivo JSON compactado
        foreach ($fileList as $fileName) {
            $url = 'https://challenges.coode.sh/food/data/json/' . trim($fileName);

            // Baixa o arquivo do link
            echo(PHP_EOL.'Baixando -> '.$fileName);
            $file = file_get_contents($url);

            // Salva o arquivo compactado no armazenamento local
            Storage::put('products/'.$fileName, $file);

            // Caminho de destino para o arquivo baixado
            $destination = storage_path('app/products/'.$fileName);

            // Criar um stream para leitura do arquivo compactado
            $gzippedStream = gzopen($destination, 'r');

            // Contador para controlar o número de itens lidos
            $itemCount = 0;

            // Variável para armazenar as linhas acumuladas
            $lineBuffer = '';

            // Iniciar a leitura em stream
            while (!gzeof($gzippedStream) && $itemCount < 100) {
                $line = gzgets($gzippedStream, 1024); // Ler uma linha do arquivo

                // Adicionar a linha ao buffer
                $lineBuffer .= $line;

                // Verifica se a linha contém um JSON completo
                if (strpos($line, '}') !== false) {
                    // Tentar decodificar o JSON
                    $data = json_decode($lineBuffer, true);

                    if ($data !== null) { // Verifica se o JSON foi decodificado com sucesso

                        // Adicionar os campos personalizados
                        $data['last_modified_t'] = now();
                        $data['imported_t'] = now();

                        // Filtra os campos específicos que serão inseridos no banco de dados
                        $data = array_intersect_key($data, array_flip($fillableAttributes));

                        // Adicionar produto no banco de dados
                        try{
                            // Insere ou atualiza o registro do produto com base no atributo 'code'
                            Product::upsert([
                                $data,
                                $data
                            ], uniqueBy: ['code']);
                        }catch (Exception $e){
                            ErrorLog::create([
                                'name' => 'Command/ImportProduct',
                                'error' => $e
                            ]);
                        }

                        // Incrementar o contador de itens lidos
                        $itemCount++;

                        // Limpar o buffer para a próxima linha
                        $lineBuffer = '';
                    }
                }
            }

            echo(' -> Produtos cadastrados no banco');

            // Fechar o stream e excluir o arquivo compactado após a leitura
            gzclose($gzippedStream);
            unlink($destination);
        }

        // Registra no banco de dados se a Importação foi realizada de forma manual ou via CRON
        if ($this->hasOption('cron')) {
            ImportHistory::create([
                'type' => 'cron'
            ]);
        }else{
            ImportHistory::create([
                'type' => 'manual'
            ]);
        }

        echo(PHP_EOL.'Importação concluída!');
    }
}
