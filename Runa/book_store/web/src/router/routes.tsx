import { AppLayout } from '../components/AppLayout';
import { HomePage } from '../pages/home/HomePage';
import type { RouteObject } from 'react-router-dom';
import { UiPreviewPage } from '../pages/UiPreviewPage';
import { LoginPage } from '../pages/login/LoginPage';
import { RegisterPage } from '../pages/register/RegisterPage';
import { AccountPage } from '../pages/account/AccountPage';
import { RequireAuth } from './RequireAuth';
import { GuestOnly } from './GuestOnly';

export const routes: RouteObject[] = [
  {
    element: <AppLayout />,
    children: [
      { path: '/', element: <HomePage /> },
      {
        element: <RequireAuth />,
        children: [{ path: '/account', element: <AccountPage /> }],
      },
      { path: '/cart', element: <p>Cart</p> },
    ],
  },
  { path: '/dev/ui', element: <UiPreviewPage /> },
  {
    path: '/login',
    element: (
      <GuestOnly>
        <LoginPage />
      </GuestOnly>
    ),
  },
  {
    path: '/register',
    element: (
      <GuestOnly>
        <RegisterPage />
      </GuestOnly>
    ),
  },
];
