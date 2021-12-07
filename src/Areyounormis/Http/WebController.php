<?php

declare(strict_types=1);

namespace Areyounormis\Http;

use Areyounormis\Report\UserReportFacade;
use Areyounormis\Report\UserReportService;
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

    public function getUserReportById(ServerRequest $request): HtmlResponse
    {
        $userId = $request->getQueryParams()['user_id'] ?? '4023229';

        $userReport = $this->userReportService->collectUserReportByUserId($userId);
        $userReportFacade = new UserReportFacade($userReport);

        $view = $this->templateRenderer->render('report/user-report', $userReportFacade->getPrettyUserReport());

        return new HtmlResponse($view);
    }
}