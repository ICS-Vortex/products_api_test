<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'product:import',
    description: 'This command is used to import products from products.json file',
)]
class ProductImportCommand extends Command
{
    private EntityManagerInterface $manager;
    private ParameterBagInterface $parameterBag;

    public function __construct(EntityManagerInterface $manager, ParameterBagInterface $parameterBag)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->parameterBag = $parameterBag;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fs = new Filesystem();
        $path = $this->parameterBag->get('kernel.project_dir');
        $file = $path . '/products.json';
        if (!$fs->exists($file)) {
            $io->error("File {$file} not found");
            return Command::FAILURE;
        }
        $content = json_decode(file_get_contents($file), true);
        try {
            foreach ($content as $item) {
                $product = new Product();
                $product->setName($item['name']);
                $product->setPrice($item['price']);
                $product->setCategory($this->manager->getRepository(Category::class)->findOneBy(['name' => $item['categoryName']]));
                $this->manager->persist($product);
            }
            $this->manager->flush();
            $io->success("All products were imported with success");
            return Command::SUCCESS;
        } catch (Exception $e) {
            $io->error("Failed to import products");
            $io->error($e->getMessage());
            $io->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
