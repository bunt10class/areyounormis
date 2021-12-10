<?php

declare(strict_types=1);

namespace Areyounormis\Http;

use Areyounormis\Report\UserReportService;
use Core\Exceptions\RequestException;
use Core\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;

class WebController
{
    protected UserReportService $userReportService;
    protected TemplateRenderer $templateRenderer;

    public function __construct(
        UserReportService $userReportService,
        TemplateRenderer $templateRenderer,
    ) {
        $this->userReportService = $userReportService;
        $this->templateRenderer = $templateRenderer;
    }

    public function index(): HtmlResponse
    {
        return new HtmlResponse($this->templateRenderer->render('report/user-report-create'));
    }

    public function collectUserReportToQueue(ServerRequest $request): HtmlResponse
    {
        try {
            $userReportRequest = new UserReportRequest($request);
        } catch (RequestException $exception) {
            return new HtmlResponse($this->templateRenderer->render('report/user-report-create', [
                'error_message' => $exception->getMessage(),
            ]));
        }

        $userId = $userReportRequest->getUserId();
        $this->userReportService->collectToQueue($userId);

        return new HtmlResponse($this->templateRenderer->render('report/message-collect', ['user_id' => $userId]));
    }

    public function getUserReport(ServerRequest $request): HtmlResponse
    {
        try {
            $userReportRequest = new UserReportRequest($request);
        } catch (RequestException $exception) {
            return new HtmlResponse($this->templateRenderer->render('common/invalid-request', [
                'error_message' => $exception->getMessage(),
            ]));
        }

        $report = $this->userReportService->get($userReportRequest->getUserId());

        if ($report) {
            $view = $this->templateRenderer->render('report/user-report', $report);
        } else {
            $view = $this->templateRenderer->render('report/message-not-exist');
        }

        return new HtmlResponse($view);
    }

    public function deleteUserReport(ServerRequest $request): HtmlResponse
    {
        try {
            $userReportRequest = new UserReportRequest($request);
        } catch (RequestException $exception) {
            return new HtmlResponse($this->templateRenderer->render('common/invalid-request', [
                'error_message' => $exception->getMessage(),
            ]));
        }

        $this->userReportService->delete($userReportRequest->getUserId());

        return new HtmlResponse($this->templateRenderer->render('report/message-delete'));
    }

    public function collectUserReport(ServerRequest $request): HtmlResponse
    {
        try {
            $userReportRequest = new UserReportRequest($request);
        } catch (RequestException $exception) {
            return new HtmlResponse($this->templateRenderer->render('common/invalid-request', [
                'error_message' => $exception->getMessage(),
            ]));
        }

        $report = $this->userReportService->collectFacade($userReportRequest->getUserId())->getPrettyWithTops();

        return new HtmlResponse($this->templateRenderer->render('report/user-report', $report));
    }

    public function getPageNotExist(): HtmlResponse
    {
        return new HtmlResponse($this->templateRenderer->render('common/page-not-exist'));
    }
}