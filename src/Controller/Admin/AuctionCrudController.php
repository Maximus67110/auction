<?php

namespace App\Controller\Admin;

use App\Entity\Auction;
use App\Enum\Status;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class AuctionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Auction::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextEditorField::new('description'),
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
}
