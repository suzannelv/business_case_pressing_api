<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Country;
use App\Entity\Material;
use App\Entity\OrderDetail;
use App\Entity\OrderStatus;
use App\Entity\PaymentMethod;
use App\Entity\Product;
use App\Entity\ProductDetail;
use App\Entity\Service;
use App\Entity\Staff;
use App\Entity\User;
use App\Entity\ZipCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_COUNTRY = 5;
    private const NB_ZIP_CODE = 20;
    private const NB_PAYMENT = 3;

    private const NB_PRODUCT = 20;


    public function load(ObjectManager $manager): void
    {  
        $faker = Factory::create();

        // country
        $countries=[];

        for ($i = 0; $i < self::NB_COUNTRY; $i++) {
            $country = new Country();
            $country->setName($faker->country());
            $manager->persist($country);
            $countries[] = $country;
        }

        // zip code 
        $zipCodes = [];
        for ($i = 0; $i < self::NB_ZIP_CODE; $i++) {
            $zipCode = new ZipCode();
            $zipCode->setZc($faker->postcode())
                    ->setCity($faker->city())
                    ->setCountry($faker->randomElement($countries));
            $manager->persist($zipCode);
            $zipCodes[] = $zipCode;
        }

        // users       
            $user=new User();
            $user->setFirstname($faker->firstName())
                 ->setLastname($faker->lastName())
                 ->setEmail($faker->email())
                 ->setPassword('123456')
                 ->setSex($faker->randomElement(["Femme", "homme"]))
                 ->setTel($faker->phoneNumber())
                 ->setAddress($faker->streetAddress())
                 ->setBirthday($faker->dateTimeBetween('-60 years', '-25 years'))
                 ->setMembership($faker->boolean())
                 ->setProfileUrl($faker->imageUrl(360, 360, 'animals', true, 'cats'))
                 ->setBalance($faker->randomFloat())
                 ->setZc($faker->randomElement($zipCodes));
                 $manager->persist($user);
     
        // staff
            $staff=new Staff();
            $staff->setFirstname($faker->firstName())
                  ->setLastname($faker->lastName())
                  ->setBirthday($faker->dateTimeBetween('-60 years', '-25 years'))
                  ->setEmail("admin@pressing.com")
                  ->setPassword('admin123')
                  ->setRoles(['ROLE_ADMIN'])
                  ->setProfileUrl($faker->imageUrl())
                  ->setTel($faker->phoneNumber())
                  ->setAddress($faker->streetAddress())
                  ->setAdminRole(true)
                  ->setZc($faker->randomElement($zipCodes));
            $manager->persist($staff);
       
        // payment methode
        $payments = [];
        for ($i = 0; $i < self::NB_PAYMENT; $i++) {
            $payment = new PaymentMethod();
            $payment->setName($faker->creditCardType());
            $manager->persist($payment);
            $payments[] = $payment;
        }
        

        // catégorie_product

        // 1- catégorie parent 
        $parentCategories =["Vêtements", "Linge de maison", "Accessoires", "Chaussures", "Autres" ];


        foreach ($parentCategories as $parentCategoryName) {
            $parentCategory = new Category();
            $parentCategory->setName($parentCategoryName);
            $manager->persist($parentCategory);
 
            // 2. catégorie enfant
            $childrenCategories = $this->getChildrenCategoriesForParent($parentCategoryName);

                foreach ($childrenCategories as $childCategoryName) {
                    $childCategory = new Category();
                    $childCategory->setName($childCategoryName)
                                  ->setParent($parentCategory)
                                  ->addChild($childCategory);
                    $manager->persist($childCategory);
        
                }
        }
      // product

        for($i = 0; $i<self::NB_PRODUCT; $i++) {
            $product = new Product();
            $product->setName($faker->word())
                    ->setPrice($faker->numberBetween(5, 100))
                    ->setCategory($faker->randomElement($childrenCategories));
            $manager->persist($product);
        }

        // matérial 
        $materials =["Coton", "Lin", "Soie", "Nylon", "Cuir", "Autres"];

        foreach ($materials as $materialName) {
            $material = new Material();
            $material->setName($materialName)
                     ->setPriceCoefficent($faker->randomFloat(1, 1, 2));       
            $manager->persist($material);
        }

        // services
        $services =["Lavage normal", "Nettoyer à sec", "Repassage", "Détâchement", "Blanchisserie", "Spécialiste cuir et daim", "Retouche", "Entretien spécial"];

        foreach ($services as $serviceName) {
            $service = new Service();
            $service->setName($serviceName)
                     ->setPriceCoefficent($faker->randomFloat(1, 1, 2));       
            $manager->persist($service);
        }

        // status de commande
        $statuses = [];
        $statusList =  ["En attente de paiement", "En attente de traitement","En cours de traitement", "Expédiée", "Livrée", "Annulée", "Prêt à retirer", "Retiré" ];

        foreach ($statusList as $statusName) {
           $status = new OrderStatus();
           $status->setStatus($statusName);
           $manager->persist($status);
           $statuses[] = $status;
        }

        // commande en détail

        $orderDetail = new OrderDetail();
        $orderDetail->setOrderNumber($faker->numberBetween(10000, 99999))
                    ->setPayment($faker->randomElement($payments))
                    ->setDelivery(false)
                    ->setDepositDate($faker->dateTimeBetween('-3 years'))
                    ->setRetrieveDate($faker->dateTimeBetween('-3 years'))
                    ->setStatus($faker->randomElement($statuses))
                    ->setUser($user)
                    ->setStaff($staff);

        // produit en détail dans une commande

        $productInOrder = new ProductDetail();
        $productInOrder->setDescription($faker->sentence(3))
                       ->setProduct($faker->randomElement($product))
                       ->setMaterial($faker->randomElement($material))
                       ->setService($faker->randomElement($service))
                       ->setTotalPrice(10);
        $orderDetail->addProductDetail($productInOrder);
        $manager->persist($orderDetail);
        $manager->persist($productInOrder);

        $manager->flush();
    }

    private function getChildrenCategoriesForParent(string $parentCategoryName): array
    {
        $categoryMappings = [
            "Vêtements" => ["Haut", "Bas", "Eté", "Hiver"],
            "Linge de maison" => ["Lit", "Salle de bain", "Maison"],
            "Accessoires" => ["Chapeau"],
            "Chaussures" => ["Baskets", "Chaussures de sport"],
            "Autres" => ["Peluche"],
        ];
        return $categoryMappings[$parentCategoryName];
    }

}
