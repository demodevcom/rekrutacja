<?php

require_once dirname(__FILE__) . '/../lib/kandydatGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/kandydatGeneratorHelper.class.php';

/**
 * kandydat actions.
 *
 * @package    testowy
 * @subpackage kandydat
 * @author     Tymek
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class kandydatActions extends autoKandydatActions
{

    public function executeExport(sfWebRequest $request)
    {
        @unlink(sfConfig::get('sf_data_dir') . '/pdf/export.csv');
        $h = fopen(sfConfig::get('sf_data_dir') . '/pdf/export.csv', 'w');
        if ($h) {
            //pobieramy wszystkie rekordy
            $q = Doctrine_Query::create()
                ->select('s.*')
                ->from('Kandydat s');
            $kandydats = $q->execute();
            $i = 0;
            foreach ($kandydats as $k) {
                $data = $k->getData();
                if ($i++ == 0) {
                    //pierwszy, wypisujemy nagłówki
                    $fields = array_keys($data);
                    foreach ($fields as $f)
                        fwrite($h, $f . '|');
                    fwrite($h, "\n");
                }
                foreach ($data as $f => $d) {
                    fwrite($h, (strlen($d) > 0 ? $d : '-') . '|');
                }
                fwrite($h, "\n");
            }
            fwrite($h, "\n");
            fclose($h);
        }
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->setHttpheader('Pragma: public', true);
        $response->addCacheControlHttpHeader('Cache-Control', 'must-revalidate');
        $response->setHttpHeader("Last-Modified", gmdate("D, d M Y H:i:s") . " GMT");
        $response->setContentType('text/plain');
        $response->setHttpHeader('Content-Description', 'File Transfer');
        $response->setHttpHeader('Content-Transfer-Encoding', 'binary', true);
        $response->setHttpHeader('Content-Disposition', 'attachment; filename=' . str_replace(" ", "_", utf8_decode('export.csv')));
        $response->sendHttpHeaders();

        $response->setContent(readfile(sfConfig::get('sf_data_dir') . '/pdf/' . '/export.csv'));
        $response->sendContent();

        return sfView::NONE;

    }

    public function executeNew(sfWebRequest $request)
    {

        $jsParams = '
	    <script type="text/javascript">     
	    	var jezyk = \'\';
	    	var jezyk2 = \'\';
	    	var specjalnosc = \'\';
	   	</script>
	   	';
        $this->getRequest()->setParameter('jsParams', $jsParams);

        parent::executeNew($request);
    }

    public function executeCreate(sfWebRequest $request)
    {

        $jsParams = '
	    <script type="text/javascript">     
	    	var jezyk = \'\';
	    	var jezyk2 = \'\';
	    	var specjalnosc = \'\';
	   	</script>
	   	';
        $this->getRequest()->setParameter('jsParams', $jsParams);

        parent::executeCreate($request);
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($kandydat = Doctrine::getTable('Kandydat')->find(array($request->getParameter('id'))), sprintf('Object kandydat does not exist (%s).', array($request->getParameter('id'))));


        // string z parametrami dla js
        $jsParams = '
	    <script type="text/javascript"> 
	    	var jezyk = ' . ($kandydat->getJezyk() != '' ? '\'' . $kandydat->getJezyk() . '\'' : '\'\'') . ';
	    	var jezyk2 = ' . ($kandydat->getJezyk2() != '' ? '\'' . $kandydat->getJezyk2() . '\'' : '\'\'') . ';
	    	var specjalnosc = ' . ($kandydat->getSpecjalnosc() != '' ? '\'' . $kandydat->getSpecjalnosc() . '\'' : '\'\'') . ';
	   	</script>
	   	';
        $this->getRequest()->setParameter('jsParams', $jsParams);

        parent::executeEdit($request);
        //echo 'Login: '.$kandydat->getLogin();
        $this->form = new BackendKandydatForm($kandydat, $kandydat->getLogin());
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($kandydat = Doctrine::getTable('Kandydat')->find(array($request->getParameter('id'))), sprintf('Object kandydat does not exist (%s).', array($request->getParameter('id'))));

        // string z parametrami dla js
        $jsParams = '
	    <script type="text/javascript"> 
	    	var jezyk = ' . ($kandydat->getJezyk() != '' ? '\'' . $kandydat->getJezyk() . '\'' : '\'\'') . ';
	    	var jezyk2 = ' . ($kandydat->getJezyk2() != '' ? '\'' . $kandydat->getJezyk2() . '\'' : '\'\'') . ';
	    	var specjalnosc = ' . ($kandydat->getSpecjalnosc() != '' ? '\'' . $kandydat->getSpecjalnosc() . '\'' : '\'\'') . ';
	   	</script>
	   	';
        $this->getRequest()->setParameter('jsParams', $jsParams);

        $this->form = $this->configuration->getForm($this->kandydat);
        $this->form = new BackendKandydatForm($kandydat, $kandydat->getLogin());

        $this->processForm($request, $this->form);
    }

    public function executeDelete(sfWebRequest $request)
    {
        $this->forward404Unless($kandydat = Doctrine::getTable('Kandydat')->find(array($request->getParameter('id'))), sprintf('Object kandydat does not exist (%s).', array($request->getParameter('id'))));

        if (@file_exists(sfConfig::get('sf_upload_dir') . '/' . $kandydat->getLogin() . '/' . $kandydat->getZdjecie())) {
            @unlink(sfConfig::get('sf_upload_dir') . '/' . $kandydat->getLogin() . '/' . $kandydat->getZdjecie());
            @rmdir(sfConfig::get('sf_upload_dir') . '/' . $kandydat->getLogin());
        }

        $this->getUser()->setFlash('notice', 'Kandydat został usunięty pomyślnie.');
        parent::executeDelete($request);

    }

    public function executeWelcome(sfWebRequest $request)
    {
        $this->setTemplate('welcome');
    }

    public function executeListChangePass(sfWebRequest $request)
    {
        $kandydat = Doctrine::getTable('Kandydat')->find(array($request->getParameter('id')));
        $this->form = new BackendPasswordKandydatForm($kandydat);
        $this->kandydat = $kandydat;
    }

    public function executeListChangeImage(sfWebRequest $request)
    {
        $kandydat = Doctrine::getTable('Kandydat')->find(array($request->getParameter('id')));
        //echo 'login: '.$kandydat->getLogin();
        $this->form = new BackendImageKandydatForm($kandydat, $kandydat->getLogin());
        $this->kandydat = $kandydat;
        $this->kandydatLogin = $kandydat->getLogin();
    }

    public function executeChangePass(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($kandydat = Doctrine::getTable('Kandydat')->find(array($request->getParameter('id'))), sprintf('Object kandydat does not exist (%s).', array($request->getParameter('id'))));
        $this->form = new BackendPasswordKandydatForm($kandydat);

        $this->processFormPass($request, $this->form);

    }

    public function executeChangeImage(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
        $this->forward404Unless($kandydat = Doctrine::getTable('Kandydat')->find(array($request->getParameter('id'))), sprintf('Object kandydat does not exist (%s).', array($request->getParameter('id'))));

        if (@file_exists(sfConfig::get('sf_upload_dir') . '/' . $kandydat->getLogin() . '/' . $kandydat->getZdjecie())) {
            @unlink(sfConfig::get('sf_upload_dir') . '/' . $kandydat->getLogin() . '/' . $kandydat->getZdjecie());
        }

        $this->form = new BackendImageKandydatForm($kandydat);

        $this->processFormImage($request, $this->form);

    }

    protected function processFormImage(sfWebRequest $request, sfForm $form)
    {

        $form->bind(
            $request->getParameter($form->getName()),
            $request->getFiles($form->getName())
        );

        if ($form->isValid()) {
            $kandydat = $form->save();
            $this->getUser()->setFlash('notice', 'Zdjęcie zostało zmienione');
            $this->redirect('kandydat/index');
        } else {
            $this->getUser()->setFlash('error', 'Wystąpiły błędy.');
            $this->setTemplate('ListChangeImage');
        }
    }

    protected function processFormPass(sfWebRequest $request, sfForm $form)
    {

        $form->bind(
            $request->getParameter($form->getName()),
            $request->getFiles($form->getName())
        );

        if ($form->isValid()) {
            $kandydat = $form->save();
            $this->getUser()->setFlash('notice', 'Hasło zostało zmienione');
            $this->redirect('kandydat/index');
        } else {
            $this->getUser()->setFlash('error', 'Wystąpiły błędy.');
            $this->setTemplate('ListChangePass');
        }
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {

        $form->bind(
            $request->getParameter($form->getName()),
            $request->getFiles($form->getName())
        );

        if ($form->isValid()) {
            $kandydat = $form->save();
            $this->getUser()->setFlash('notice', 'Dane zostały zmienione');
            $this->redirect('kandydat/index');
        } else {
            sfContext::getInstance()->getLogger()->debug('Form is not valid');
            $errors = $form->getErrorSchema()->getErrors();
            foreach ($errors as $err)
                sfContext::getInstance()->getLogger()->debug('Error: ' . $err);
            $this->kandydat = $form;
            $this->getUser()->setFlash('error', 'Wystąpiły błędy.');
            $this->setTemplate('edit');
        }
    }
}
