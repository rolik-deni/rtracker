<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class RestController
{
  /**
   * Формирует заголовок ответа.
   *
   * @param Request $request HTTP запрос
   *
   * @return array Заголовок ответа
   */
  private static function createHeaderResponse(Request $request): array
  {
    $headerResponse['request'] = [
      'uri'    => $request->getUri(),
      'method' => $request->getMethod(),
    ];

    return $headerResponse;
  }

  /**
   * Формирует ответ на запрос при успешной обработке запроса.
   *
   * @param Request $request HTTP запрос
   * @param any $data Результат выполнения запроса
   *
   * @return array Ответ
   */

  public static function createResponse(Request $request, $data = null): array
  {
    $response = self::createHeaderResponse($request);

    if (is_array($data) && $data == false) {
      $data = null;
    }

    $response['response'] = $data;

    return $response;
  }

  /**
   * Формирует ответ на запрос с указанием ошибки.
   *
   * @param Request $request HTTP запрос
   * @param string $errorMessage Сообщение ошибки
   *
   * @return array Ответ
   */
  public static function createErrorResponse(Request $request, string $errorMessage): array
  {
    $response = self::createHeaderResponse($request);

    $response['error'] = $errorMessage;

    return $response;
  }
}
