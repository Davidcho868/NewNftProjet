<?php

namespace App\Controller;

use App\Entity\Nft;
use App\Form\NFTCreationType;
use App\Repository\NftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NFTCreationController extends AbstractController
{
    #[Route('/creation-nft', name: 'nft_make')]
    #[Route('/modification-nft-{id}', name: 'nft_change', requirements: ['id' => '\d+'])]
    public function manageNFT(
        Request $request,
        NftRepository $nftRepository,
        ?NFT $nft,
    ): Response
    {
        if (is_null($nft)){
            $nft = (new Nft())->setUser($this->getUser());
            $message = 'NFT créé';
        }elseif($nft->getUser() != $this->getUser()){
            $this->addFlash('danger', 'Votre NFT est dans un autre château');
            return $this->redirectToRoute('app_default');
        }else{
            $message = "NFT modifié";
        }
        
        $form = $this->createForm(NFTCreationType::class, $nft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nftRepository->save($nft, true);
            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_home');
        }



        return $this->render('nft_creation/index.html.twig', [
            'form' => $form->createView(),
            'nft' => $nft,
        ]);
    }
}
