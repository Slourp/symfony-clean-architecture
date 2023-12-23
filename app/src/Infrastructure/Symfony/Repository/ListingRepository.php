<?php

namespace Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\HousingManagement\Gateway\ListingRepositoryI;
use Infrastructure\Symfony\Entity\Listing;
use Domain\HousingManagement\Entity\Listing as DomainListing;

/**
 * @extends ServiceEntityRepository<Listing>
 *
 * @method Listing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Listing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Listing[]    findAll()
 * @method Listing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingRepository extends ServiceEntityRepository implements ListingRepositoryI
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Listing::class);
    }

    public function save(DomainListing $listing): bool
    {
        $ormListing = new Listing();
        $ormListing
            ->setTitle($listing->getTitle()->value)
            ->setDescription($listing->getDescription()->value)
            ->setPrice($listing->getPrice()->value)
            ->setLocation($listing->getLocation())
            ->setCapacity($listing->getCapacity()->getValue());
        if ($listing->id !== null) $ormListing->setId($listing->id->value);
        $em = $this->getEntityManager();
        $em->persist($ormListing);
        $ormListing->setId($listing->id->value);
        $em->flush();
        return true;
    }
    public function findByTitleAndDescription(string $title, string $description): ?DomainListing
    {
        /**
         * @var Listing|null
         */
        $listing = $this->findOneBy(['title' => $title, 'description' => $description]);
        return ($listing !== null) ? DomainListing::fromArray($listing->toArray()) : null;
    }
    public function findById(string $uuid): ?DomainListing
    {
        /**
         * @var Listing|null
         */
        $listing = $this->findOneBy(['id' => $uuid]);
        return ($listing !== null) ? DomainListing::fromArray($listing->toArray()) : null;
    }
}
