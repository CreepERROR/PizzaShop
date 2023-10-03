<?php

namespace pizzashop\shop\domain\dto\commande;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CommandeDTO
{
    public ?string $id;
    public ?string $date_commande;
    public ?int $delai;
    public ?float $montant_total;
    public string $mail_client;
    public int $type_livraison;
    public array $itemDTO;

    public ?int $state;

    /**
     * @param string $id
     * @param string $date_commande
     * @param float $montant_total
     * @param string $mail_client
     * @param int $type_livraison
     * @param array $itemDTO
     */
    public function __construct(string $mail_client, int $type_livraison, array $itemDTO, ?string $id = null, ?string $date_commande = null, ?float $montant_total=null, ?int $state=null)
    {
        $this->mail_client = $mail_client;
        $this->type_livraison = $type_livraison;
        $this->itemDTO = $itemDTO;
        $this->id = $id;
        $this->date_commande = $date_commande;
        $this->montant_total = $montant_total;
        $this->state = $state;
    }

    public function getItems()
    {
        return $this->itemDTO;
    }

    public function setItemDTO($key, $value): void
    {
        $this->itemDTO[$key] = $value;
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('mail_client', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mail_client', new Assert\Email());

        $metadata->addPropertyConstraint('type_livraison', new Assert\NotBlank());
        $metadata->addPropertyConstraint('type_livraison', new Assert\Type('integer'));
        $metadata->addPropertyConstraint('type_livraison', new Assert\Range([
            'min' => 1,
            'max' => 3,
            //'notInRangeMessage' => 'Valeur de type de livraison non conforme',
        ]));


        $metadata->addPropertyConstraint('itemDTO', new Assert\Type('array'));
        $metadata->addPropertyConstraint('itemDTO', new Assert\NotBlank());

        //verifie les donnees dans array itemDTO
        //mais pas sure, comment faire boucle : foreach (itemDTO as item) ???
        $metadata->addPropertyConstraint('itemDTO', new Assert\Collection([
            'fields' => [
                'numero'  => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\NotNull()],
                'taille' => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\Range(['min' => 1, 'max' => 2])],
                'quantite'  => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\NotNull()]
            ],
        ]));


    }

}
