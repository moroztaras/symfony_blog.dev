<?php

namespace BlogBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Registry;

class SessionsService
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var bool
     */
    private $filterActive = false;

    /**
     * Sessions constructor.
     *
     * @param RequestStack $requestStack
     * @param Registry     $doctrine
     */
    public function __construct(RequestStack $requestStack, Registry $doctrine)
    {
        $this->requestStack = $requestStack;
        $this->doctrine = $doctrine;
    }

    /**
     * @param $form
     * @param $filter
     */
    public function updateFilterFromSession($form, $filter)
    {
        $request = $this->requestStack->getCurrentRequest();

        $session = $request->getSession();

        $filterName = $this->getFilterName($filter);

        if($request->get('reset')) {
            $session->remove($filterName);
        }

        /**
         * @var \Symfony\Component\Form\Form $form
         */
        if($form->isSubmitted()) {
            if($form->isValid()) {
                $session->set($filterName, serialize($form->getData()));
                $this->filterActive = true;
                return true;
            } else {
                return false;
            }
        } else {
            if($session->get($filterName)) {
                $this->filterActive = true;
                $em = $this->doctrine->getManager();
                $data = unserialize($session->get($filterName));
                foreach($form as $field) {
                    $fieldName = ucfirst($field->getName());
                    $getter = 'get'.$fieldName;
                    $setter = 'set'.$fieldName;

                    $value = $data->$getter();

                    if((is_object($value) && !$value instanceof \DateTime) || (is_array($value) && isset($value[0]) && is_object($value[0]))) {
                        $entities=[];
                        foreach($value as $entity) {
                            $entities[] = $em->merge($entity);
                        }
                        $field->setData($entities);
                    } else {
                        $field->setData($value);
                    }

                    $filter->$setter($value);
                }
            }
        }
        return true;
    }

    /**
     * @param $filter
     * @return string
     */
    public function getFilterName($filter)
    {
        return substr(md5(get_class($filter)), 0, 10);
    }

    /**
     * @return bool
     */
    public function getFilterStatus()
    {
        return $this->filterActive;
    }

}