<?php

namespace Darkish\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recordNumber')
            ->add('title')
            ->add('subTitle')
            ->add('owner')
            ->add('legalName')
            ->add('centerFloor')
            ->add('centerUnitNumber')
            ->add('messageEnable')
            ->add('messageText')
            ->add('messageInsertDate')
            ->add('messageValidityDate')
            ->add('safarsaz')
            ->add('safarsazRank')
            ->add('telNumberOne')
            ->add('telNumberTwo')
            ->add('telNumberThree')
            ->add('telNumberFour')
            ->add('faxNumberOne')
            ->add('faxNumberTwo')
            ->add('mobileNumberOne')
            ->add('mobileNumberTwo')
            ->add('email')
            ->add('website')
            ->add('address')
            ->add('longitude')
            ->add('latitude')
            ->add('reserved1')
            ->add('reserved2')
            ->add('brandEnable')
            ->add('listRank')
            ->add('mOpeningHoursFrom')
            ->add('mOpeningHoursTo')
            ->add('aOpeningHoursFrom')
            ->add('aOpeningHoursTo')
            ->add('workingDays')
            ->add('searchKeywords')
            ->add('creationDate')
            ->add('lastUpdate')
            ->add('favoriteEnable')
            ->add('likeEnable')
            ->add('sendSmsEnable')
            ->add('infoKeyEnable')
            ->add('commentEnable')
            ->add('onlyHtml')
            ->add('onlineEnable')
            ->add('dbaseEnable')
            ->add('bulkSmsEnable')
            ->add('audio')
            ->add('video')
            ->add('onlineMarket')
            ->add('onlineTicket')
            ->add('visitCount')
            ->add('favoriteCount')
            ->add('likeCount')
            ->add('verify')
            ->add('centerIndex')
            ->add('areaIndex')
            ->add('safarsazTypeIndex')
            ->add('dbaseTypeIndex')
            ->add('trees')
            ->add('images')
            ->add('videos')
            ->add('audios')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CategoryBundle\Entity\Record',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkish_categorybundle_record';
    }
}
