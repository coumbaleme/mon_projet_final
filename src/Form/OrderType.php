<?php
// src/Form/OrderType.php
// ✅ Formulaire LIÉ à l'entité Order (data_class = Order::class)
// 🧠 On expose SEULEMENT les champs que l'utilisateur doit remplir.
namespace App\Form;
use App\Entity\Order;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class OrderType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
// Champ mappé sur Order::email
->add('email', EmailType::class, [
'label' => 'Votre email',
'required' => true,
])
// Champ mappé sur Order::shippingAddress (ex. adresse de livraison)
->add('shippingAddress', TextareaType::class, [
'label' => 'Adresse de livraison',
'required' => false,
'attr' => ['rows' => 3],
]);
// ⚠️ NE PAS exposer total/status/createdAt ici : on les fixe côté contrôleur
// pour éviter toute manipulation depuis le client.
}
public function configureOptions(OptionsResolver $resolver): void
{
$resolver->setDefaults([
'data_class' => Order::class, // 👈 Lie le form à l'entité Order
]);
}
}
