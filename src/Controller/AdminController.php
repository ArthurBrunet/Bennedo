<?php

namespace App\Controller;


use App\Entity\Admin;
use App\Entity\Report;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController

{
    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(ObjectManager $em)
    {
        $this->em = $em;

    }

    /**
     * @Route("/admin/create", name="admin.create")
     * @param Request $request
     * @return Response
     */

    public function addAdmin(Request $request)
    {
        $datas = json_decode($request->getContent(), true);
        var_dump($datas);
        $admin = new Admin();
        $admin
            ->setLogin($datas['login'])
            ->setPassword(password_hash($datas['password'], PASSWORD_BCRYPT))
            ->setRole($datas['role'])
            ->setToken($datas['token']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();
        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/admin/all", name="admin.all")
     * @return Response
     */
    public function allAdmin()
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAllAdmin();
        if (empty($admin)) {
            return new Response('No element was found.');
        } else {
            $response = new Response(json_encode($admin));
            $response->headers->set('Content-type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/admin/{id}", name="admin.one")
     * @param $id
     * @return Response
     */

    public function oneAdmin($id)
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAdmin($id);

        if (empty($admin)) {
            return new Response('No element containing this ID was found.');
        } else {
            $res = new Response(json_encode($admin));
            $res->headers->set('Content-type', 'application/json');
            return $res;
        }

    }

    public function removeReport($id)
    {

    }

    /**
     * @Route("/admin/remove-admin/{id}", name="admin.remove.admin")
     * @param $id
     * @return Response
     */
    public function removeAdmin($id)
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAdmin($id);

        if (!$admin) {
            return new Response("Processing cannot be performed because no element has been found.");
        } else {
            $this->getDoctrine()->getRepository(Admin::class)->removeAdmin($id);
            return new Response("Administrator successfully deleted.");
        }

    }

    /**
     * @Route("/admin/remove-report/{id}", name="admin.remove.report")
     * @param $id
     * @return Response
     */

    public function moveReport($id)
    {
        $report = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findReport($id);

        if (!$report) {
            return new Response("Processing cannot be performed because no element has been found.");

        } else {
            $this->getDoctrine()->getRepository(Report::class)->removeReport($id);
            return new Response("Report successfully deleted");
        }
    }

}