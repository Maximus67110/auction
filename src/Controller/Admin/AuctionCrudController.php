<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\TranslationField;
use App\Entity\Auction;
use App\Enum\Status;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuctionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Auction::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsConfig = [
            'title' => [
                'field_type' => TextType::class,
                'required' => true,
            ],
            'description' => [
                'field_type' => TextareaType::class,
                'required' => true,
            ]
        ];

        return [
            TranslationField::new('translations', null, $fieldsConfig)
                ->setRequired(true)
                ->hideOnIndex(),
            MoneyField::new('price')->setCurrency('EUR'),
            DateTimeField::new('dateOpen'),
            DateTimeField::new('dateClose'),
            ImageField::new('image')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
                ->setRequired(false),
            ChoiceField::new('status')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions([
                    'class' => Status::class,
                    'choices' => Status::cases()
                ]),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setFormThemes(
                [
                    '@A2lixTranslationForm/bootstrap_5_layout.html.twig',
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            );
    }
}
