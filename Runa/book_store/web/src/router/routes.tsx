import type { RouteObject } from 'react-router-dom';
import { UiPreviewPage } from '../pages/UiPreviewPage';
import { LoginPage } from '../pages/login/LoginPage';
import { RegisterPage } from '../pages/register/RegisterPage';
import { AccountPage } from '../pages/account/AccountPage';
import { RequireAuth } from './RequireAuth';
import { GuestOnly } from './GuestOnly';
import { AppLayout } from '../components/AppLayout';
import { HomePage } from '../pages/home/HomePage';

export const routes: RouteObject[] = [
  {
    element: <AppLayout />,
    children: [
      { index: true, element: <HomePage /> },
      { path: 'cart', element: <p className="px-4 py-8">Cart</p> },
      { path: 'books/:id', element: <p className="px-4 py-8">Book</p> },
      {
        element: <RequireAuth />,
        children: [{ path: 'account', element: <AccountPage /> }],
      },
      {
        path: 'login',
        element: (
          <GuestOnly>
            <LoginPage />
          </GuestOnly>
        ),
      },
      {
        path: 'register',
        element: (
          <GuestOnly>
            <RegisterPage />
          </GuestOnly>
        ),
      },
    ],
  },
  { path: '/dev/ui', element: <UiPreviewPage /> },
];
