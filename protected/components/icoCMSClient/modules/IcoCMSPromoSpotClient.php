<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSPromoSpotClient extends BaseIcoCMSClient {

    protected function getModel() {
        return PromoSpot::model();
    }

    public function getPost($promoSpotKey) {

        $promoSpot = $this->getModuleModel($promoSpotKey);

        if ($promoSpot != null) {
            $client = new IcoCMSPostClient();
            return $client->getById($promoSpot->Value);
        }

        return null;
    }

    private function getModuleModel($promoSpotKey) {
        return PromoSpot::model()->findByAttributes(array(
                    "Key" => $promoSpotKey
                ));
    }

}

?>
