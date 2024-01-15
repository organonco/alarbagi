<?php

namespace Organon\Marketplace\Console\Commands;

use Illuminate\Console\Command;
use Organon\Marketplace\Models\Admin;
use Webkul\Category\Database\Factories\CategoryFactory;
use Webkul\Category\Models\Category;
use Webkul\Category\Models\CategoryTranslation;
use Webkul\Product\Repositories\ProductRepository;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Categories From CSV File';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    private function createCategory($name, $parent_id = 1)
    {
        return Category::whereHas('translations', function($q) use ($name){
            $q->where('name', $name);
        })->first()?? Category::factory()->hasTranslations(['name' => $name, 'slug' => $name, 'description' => ''])->create(['name' => $name, 'parent_id' => $parent_id]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $CSVfp = fopen($this->argument('file'), "r");
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        if ($CSVfp !== FALSE) {
            while (! feof($CSVfp)) {
                $data = fgetcsv($CSVfp, 1000, ",");
                if (! empty($data)) {
                    $parent = $this->createCategory($data[0]);
                    for($i = 1; $i < count($data); $i++){
                        if($data[$i])
                            $parent = $this->createCategory($data[$i], $parent->id);
                    }
                }
            }
        }
        fclose($CSVfp);
        return 1;
    }
}
