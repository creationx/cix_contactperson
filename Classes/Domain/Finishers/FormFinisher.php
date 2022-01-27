<?php
namespace Creationx\CixContactperson\Domain\Finishers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Object\ObjectManager;

class FormFinisher extends  \TYPO3\CMS\Form\Domain\Finishers\EmailFinisher {

    /**
     * addressRepository
     *
     * @var \Creationx\CixContactperson\Domain\Repository\AddressRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $addressRepository = NULL;


    /**
    * Executes this finisher
    * @see AbstractFinisher::execute()
    *
    * @throws FinisherException
    */
    protected function executeInternal()
    {
        $formValues = $this->finisherContext->getFormValues();

        if(isset($formValues['hidden-1']) && (int)$formValues['hidden-1'] > 0)
        {
            $oObjectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $oAddressRepo   = $oObjectManager->get('Creationx\\CixContactperson\\Domain\\Repository\\AddressRepository');
            $oAddress       = $oAddressRepo->findByUid((int)$formValues['hidden-1']);
            $sEmail         = $oAddress->getEmail();

            if(strlen($sEmail) > 0) {
                $this->setOption('recipients', [$sEmail]);
            }
        }

        parent::executeInternal();

    }
}