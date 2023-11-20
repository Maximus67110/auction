<?php

namespace App\Controller\Admin;

use App\Entity\Raise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class RaiseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Raise::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            MoneyField::new('price')->setCurrency('EUR'),
            DateTimeField::new('createdAt'),
        ];
    }
}
