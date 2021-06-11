<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Status;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('status', EntityType::class, [
                'class' => Status::class, 'description',
//                'choice_label' => function (Status $status) {
//                    return "{$status->getDescription()} - {$status->getClasse()}";
//                },
                'expanded' => false,
                'multiple' => false
            ])
            ->add('departements', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'designation',
                'expanded' => false,
                'multiple' => true
            ])
            ->add('AddTicket', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
