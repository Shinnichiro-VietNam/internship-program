import { UiPreviewPage } from "../pages/UiPreviewPage";
import type { RouteObject } from "react-router-dom";

export const routes: RouteObject[] = [
    {
        path: '/dev/ui',
        element: <UiPreviewPage />,
    }
]