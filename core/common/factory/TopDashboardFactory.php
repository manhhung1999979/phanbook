<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Phanbook\Factory;

class TopDashboardFactory extends TopDashboardFactoryMethod
{
    private $batchAnalytic;
    private $analyticClient;
    public function setAnalytic($analyticClient)
    {
        $this->analyticClient = $analyticClient;
        $this->analyticClient->setUseBatch(true);
    }
    protected function createTopDashboard($dimension)
    {
        switch ($dimension) {
            case parent::Visits:
                return new Visits();
                break;
            case parent::PageViews:
                return new PageViews();
                break;
            case parent::TimeOnPage:
                return new TimeOnPage();
                break;
            case parent::BounceRate:
                return new BounceRate();
                break;
            default:
                return null;
                break;
        }
    }
    public function create($dimension)
    {
        $obj = $this->createTopDashboard($dimension);
        $obj->setAnalytic($this->analyticClient);
        $obj->setDimension($dimension);
        $obj->create();
        return $obj;
    }
    public function executeBatch()
    {
        $result = $this->analyticClient->batchExecute();
        $this->analyticClient->setUseBatch(false);
        return $result;
    }
}








