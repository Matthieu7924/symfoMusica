<?php

namespace App\Controller;

use App\Entity\Song;
use App\Form\SongType;
use App\Repository\SongRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SongController extends AbstractController
{
    #[Route('/song', name: 'app_song')]
    public function index(
        PaginatorInterface $paginator,
        SongRepository $songRepo,
        Request $request
    ): Response
    {
        $songs = $paginator->paginate(
            $songRepo->findAll(), // $query, query NOT result
            $request->query->getInt('page', 1), // page number
            10 // limit per page
        );
        return $this->render('song/index.html.twig', [
            'songs' => $songs,
        ]);
    }

    //CREATION SONG
    #[Route('/create-song', name: 'create_song')]
    public function new(
        Request $request,
        EntityManagerInterface $em
    ): Response
    {
        $song = new Song();
        $form = $this->createForm(SongType::class, $song);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) // Check if the form is submitted and valid
        {
            // dd($form->getData());
            $song = $form->getData();
            $em->persist($song);
            $em->flush();

            $this->addFlash(
                'success',
                'chanson correctement ajoutée!'
            );
            
            return $this->redirectToRoute('app_song');
        }
        return $this->render('pages/song/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //EDITION SONG
    #[Route('/song/edition/{id}', name: 'song_update', methods:['GET', 'POST'])]
    /**
     * Undocumented function
     *
     * @param SongRepository $repo
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(
        SongRepository $repo,
        int $id,
        Request $request, 
        EntityManagerInterface $em 
        ):Response
    {
        //soit on passe par le repoitory avec comme paramètres de la fonction IngredientRepository $repo et  $id
        $song = $repo->findOneBy(['id' => $id]);
        //soit on passe par l'objet
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $song = $form->getData();
            $em->persist($song);
            $em->flush($song);
        
            $this->addFlash(
                'success',
                'chanson mise a jour'
            );
            return $this->redirectToRoute('app_song');
        }
        return $this->render('pages/recette/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }



}
