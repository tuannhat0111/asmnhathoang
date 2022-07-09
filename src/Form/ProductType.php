<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\TypePerfumeRepository;
use App\Entity\TypePerfume;

class ProductType extends AbstractType
{
    private $em;
    private $typePerfumeRepository;

    public function __construct(ManagerRegistry $registry, TypePerfumeRepository $typePerfumeRepository)
    {
        $this->em = $registry;
        $this->typePerfumeRepository = $typePerfumeRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('quantity')
            ->add('price')
            ->add('information')
            ->add('brand', EntityType::class,[
                'class' => TypePerfume::class
            ])
        ;
    }
        

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
