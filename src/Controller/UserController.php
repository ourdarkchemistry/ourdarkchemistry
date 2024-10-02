namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", methods={"POST"})
     */
    public function createUser(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $user->setEmail($data['email']);
        
        $em->persist($user);
        $em->flush();
        
        return $this->json($user, Response::HTTP_CREATED);
    }

    /**
     * @Route("/users/{id}", methods={"PUT"})
     */
    public function updateUser(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        
        $em->flush();
        
        return $this->json($user);
    }

    /**
     * @Route("/users/{id}", methods={"DELETE"})
     */
    public function deleteUser(EntityManagerInterface $em, int $id): Response
    {
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($user);
        $em->flush();
        
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $em->getRepository(User::class)->findOneBy(['username' => $data['username']]);
        
        if ($user && password_verify($data['password'], $user->getPassword())) {
            return $this->json(['message' => 'Login successful']);
        }

        return $this->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function getUser(EntityManagerInterface $em, int $id): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        
        return $this->json($user);
    }
}
