import { UiPreviewPage } from "../pages/UiPreviewPage";
import type { RouteObject } from "react-router-dom";
import { LoginPage } from "../pages/login/LoginPage";
import { RegisterPage } from "../pages/register/RegisterPage";

export const routes: RouteObject[] = [
    {
        path: '/dev/ui',
        element: <UiPreviewPage />,
    },
    {
        path: '/login',
        element: <LoginPage />,
    },
    {
        path: '/register',
        element: <RegisterPage />,
    },
]