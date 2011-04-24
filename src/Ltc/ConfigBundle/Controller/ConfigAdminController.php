<?php

namespace Ltc\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ltc\ConfigBundle\Document\Config;
use Ltc\ConfigBundle\Form\ConfigForm;

class ConfigAdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcConfigBundle:Admin:index.html.twig', array(
            'configs' => $this->get('ltc_config.manager')->getConfigs()
        ));
    }

    public function editAction($name)
    {
        $this->get('ltc_admin.menu.main')->getChild('Config')->setIsCurrent(true);
        $config = $this->get('ltc_config.manager')->getConfig($name);
        $document = $config->getDocument();
        $form = $this->get('form.factory')->create($config->getFormType());
        $form->setData($document);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->get('doctrine.odm.mongodb.document_manager')->flush();
                $this->get('session')->setFlash('notice', 'Modifications enregistrees');

                return new RedirectResponse($this->get('router')->generate('ltc_config_admin_edit', array(
                    'name' => $name
                )));
            }
        }

        return $this->render(sprintf('LtcConfigBundle:Admin:edit_%s.html.twig', $name), array(
            'config'   => $config,
            'document' => $document,
            'form'     => $form->createView()
        ));
    }
}
