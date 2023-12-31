<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ActivityArea;
use App\Entity\ContractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email')
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('firstname')  
        ->add('lastname')   
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
            ],
            'multiple' => true, // Allow selecting multiple roles if necessary
            'expanded' => true]) // Render the roles as checkboxes or radio      
        ->add('activityarea', EntityType::class, [
            'class' => ActivityArea::class,
            'choice_label' => 'name'
        ])  
        ->add('contracttype', EntityType::class, [
            'class' => ContractType::class,
            'choice_label' => 'name'
        ])
        ->add('releasedate', DateType::class, [
            'label' => 'Date de fin de contrat',
            'format' => 'yyyy-MM-dd', // Format de la date
        ])
        ->add('pictureFile', FileType::class, [   
            'label' => 'Profile Picture',
            'mapped' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                        'image/webp',
                        'image/gif',
                        'image/jpeg',
                        'image/svg',
                    ],
                    'mimeTypesMessage' => 'the file is not valid',
                    'maxSizeMessage' => 'Max size is 1024'
                ])
            ],
            'required' => false,
        ])

        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ])
        
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
