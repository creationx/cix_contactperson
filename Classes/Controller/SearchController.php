<?php
namespace Creationx\CixContactperson\Controller;

use Creationx\CixContactperson\Domain\Model\Address;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

use TYPO3\CMS\Core\Utility\DebugUtility;

class SearchController extends ActionController
{
    public $contentObj;

    /**
     * addressRepository
     *
     * @var \Creationx\CixContactperson\Domain\Repository\AddressRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $addressRepository = NULL;

    public function initializeAction() {
        $this->contentObj = $this->configurationManager->getContentObject();
    }

    public function formAction()
    {

    }

    public function searchAction()
    {
        $args 			= GeneralUtility::_GP('tx_cixcontactperson_search');
        $sSuche         = isset($args['search']) ? $args['search']['keyword'] : null;
        $iRadius        = isset($args['radius']) ? (int)$args['radius'] : 30;
        $sMode          = isset($this->settings['mode']) ? $this->settings['mode'] : 'radius';

        $aRows          = [];

        $aCixZips       = [];
        $aCixKeywords   = [];

        switch($sMode)
        {
            case 'radius':
                $oZipRepo   = $this->objectManager->get('Creationx\\CixContactperson\\Domain\\Repository\\ZipRepository');
                $oResZip    = $oZipRepo->findByZip($sSuche);
                if($oResZip && count($oResZip) > 0)
                {
                    $oSearchRepo = $this->objectManager->get('Creationx\\CixContactperson\\Domain\\Repository\\SearchRepository');
                    $oResSearch = $oSearchRepo->findByRadius($oResZip['lat'], $oResZip['lng'], $iRadius);

                    foreach($oResSearch AS $row)
                    {
                        $aRows[] = $this->addressRepository->findByUid($row['uid']);
                    }
                }
                break;

            case 'category':
                $oSearchRepo    = $this->objectManager->get('Creationx\\CixContactperson\\Domain\\Repository\\SearchRepository');
                $oCategories    = $oSearchRepo->findByCategory($sSuche);
                $aFilterCats    = [];

                if(count($oCategories) > 0)
                {
                    foreach($oCategories AS $category)
                    {
                        if(!isset($aCixZips[(int)$category['uid']]))
                        {
                            $aCixZips[(int)$category['uid']] = $category['cix_zips'];
                            $aCixKeywords[(int)$category['uid']] = $category['cix_keywords'];
                        }
                        $aFilterCats[] = (int)$category['uid'];
                    }

                    if(count($aFilterCats) > 0)
                    {
                        $aResults       = $oSearchRepo->findByCategoryRelation($aFilterCats);
                        if(count($aResults) > 0)
                        {
                            foreach($aResults AS $address)
                            {
                                $aRows[] = $this->addressRepository->findByUid((int)$address['uid_foreign']);
                            }
                        }
                    }
                }
                break;
        }


        $this->view->assign('radius', $iRadius);
        $this->view->assign('search', $sSuche);
        $this->view->assign('results', $aRows);
        $this->view->assign('cixZips', $aCixZips);
        $this->view->assign('cixKeywords', $aCixKeywords);
    }

    public function detailsAction(Address $address)
    {
        $aCixZips       = [];
        $aCixKeywords   = [];

        $oSearchRepo    = $this->objectManager->get('Creationx\\CixContactperson\\Domain\\Repository\\SearchRepository');

        foreach($address->getCategories() AS $category)
        {
            $oCategories    = $oSearchRepo->findByUid($category->getUid());

            if(count($oCategories) > 0) {
                foreach ($oCategories as $catSec) {
                    if (!isset($aCixZips[(int)$catSec['uid']])) {
                        $aCixZips[(int)$catSec['uid']] = $catSec['cix_zips'];
                        $aCixKeywords[(int)$catSec['uid']] = $catSec['cix_keywords'];
                    }
                }
            }

        }

        $this->view->assign('address', $address);
        $this->view->assign('cixZips', $aCixZips);
        $this->view->assign('cixKeywords', $aCixKeywords);
    }

    public function performAction(Address $address)
    {
        $this->forward('details');
    }
}