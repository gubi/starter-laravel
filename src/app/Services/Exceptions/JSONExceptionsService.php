<?php
namespace Zikkio\Services\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Zikkio\Http\Behaviors\JsonApiResponses;

class JSONExceptionsService implements ExceptionsHandlerContract 
{
    use JsonApiResponses;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Transforms the exception in a JSON response
     * @param $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderException($request, Exception $exception)
    {
        $defaultResponseInfo = [
            "message" => "An error occurred",
            "status" => 400,
        ];
        $responseInfo = $this->getResponseInfoFromExceptionClass($exception) ?: $defaultResponseInfo;

        return $this->respondError("An error occurred", $responseInfo['message'], 0, $responseInfo['status']);
    }

    /**
     * @param Exception $exception
     */
    public function reportException(Exception $exception)
    {
        $this->logger->notice("Exception thrown: ".get_class($exception), [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }

    protected function getResponseInfoFromExceptionClass(Exception $exception)
    {
        $classMessageMapping = [
            Exception::class => ["message" => "An error occurred", "status" => 500],
            \PDOException::class => ["message" => "An error occurred", "status" => 500],

            ModelNotFoundException::class => ["message" => "The resource requested does not exist or has been deleted", "status" => 404],
            RouteNotFoundException::class => ["message" => "There is nothing on this endpoint", "status" => 404],
            NotFoundHttpException::class => ["message" => "There is nothing on this endpoint", "status" => 404],

            AuthorizationException::class => ["message" => "You are not allowed to perform this action", "status" => 403],
            AuthenticationException::class => ["message" => "You need to be authenticated to perform this action", "status" => 401],
        ];
        $exceptionClass = get_class($exception);
        if(array_key_exists($exceptionClass, $classMessageMapping))
        {
            return $classMessageMapping[$exceptionClass];
        }
        else
        {
            return null;
        }
    }
}