<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 02/02/18
 * Time: 20:55
 */

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use FOS\ElasticaBundle\Doctrine\RepositoryManager;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProductCommand extends Command
{
    private $em;
    /** @var RepositoryManager */
    private $fm;

    public function __construct(EntityManagerInterface $em, RepositoryManagerInterface $fm)
    {
        $this->em = $em;
        $this->fm = $fm;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('app:product')
             ->addArgument('action', InputArgument::OPTIONAL, 'action', 'create')
            ->addOption('integer', null, InputOption::VALUE_NONE, '');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->{$input->getArgument('action')}($input);
    }

    private function create(InputInterface $input)
    {
        $priceTtc = ($input->getOption('integer')) ? rand(10, 20) : 33.33;

        $product = new Product();
        $product->setName(uniqid());
        $product->setPriceTtc($priceTtc);

        $this->em->persist($product);
        $this->em->flush();

        dump($product);
    }

    private function list(InputInterface $input)
    {
        dump('list');

        $repository = $this->fm->getRepository(Product::class);

        $products = $repository->find('*');

        dump($products);
    }
}