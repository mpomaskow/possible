<?php

class errorActions extends sfActions {
    const TIMEOUT = 10; //in seconds

    public function executeError404(sfWebRequest $request) {
        $response = $this->getResponse();
        $response->setTitle("Błąd 404");

        $url_to_redirect = $this->generateUrl('homepage');
//        zakomentowane bo jak google przekieruje na jakas strone ktorej nie ma to sie zapetla
//        if($request->getReferer()) {
//            $url_to_redirect = $request->getReferer();
//        }
        $response->addHttpMeta('refresh', sprintf('%s; url=%s', self::TIMEOUT, $url_to_redirect));
    }
}
?>
