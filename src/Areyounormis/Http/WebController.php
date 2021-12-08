<?php

declare(strict_types=1);

namespace Areyounormis\Http;

use Areyounormis\Report\UserReportService;
use Core\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;

class WebController
{
    private const DEFAULT_USER_ID = '4023229';

    protected UserReportService $userReportService;
    protected TemplateRenderer $templateRenderer;

    public function __construct(
        UserReportService $userReportService,
        TemplateRenderer $templateRenderer,
    ) {
        $this->userReportService = $userReportService;
        $this->templateRenderer = $templateRenderer;
    }

    public function generateUserReport(ServerRequest $request): HtmlResponse
    {
        $userId = $request->getQueryParams()['user_id'] ?? self::DEFAULT_USER_ID;

        $this->userReportService->generateSaveUserReport($userId);

        return new HtmlResponse($this->templateRenderer->render('report/message-generate'));
    }

    public function getUserReport(ServerRequest $request): HtmlResponse
    {
        $userId = $request->getQueryParams()['user_id'] ?? self::DEFAULT_USER_ID;

        $report = $this->userReportService->getUserReport($userId);

        if ($report) {
            $view = $this->templateRenderer->render('report/user-report', $report);
        } else {
            $view = $this->templateRenderer->render('report/message-not-exist');
        }

        return new HtmlResponse($view);
    }

    public function deleteUserReport(ServerRequest $request): HtmlResponse
    {
        $userId = $request->getQueryParams()['user_id'] ?? self::DEFAULT_USER_ID;

        $this->userReportService->deleteUserReport($userId);

        return new HtmlResponse($this->templateRenderer->render('report/message-delete'));
    }

    public function generateGetUserReport(ServerRequest $request): HtmlResponse
    {
        $userId = $request->getQueryParams()['user_id'] ?? self::DEFAULT_USER_ID;

        $report = $this->userReportService->collectUserReportFacade($userId)->getPrettyUserReport();

        return new HtmlResponse($this->templateRenderer->render('report/user-report', $report));
    }
}