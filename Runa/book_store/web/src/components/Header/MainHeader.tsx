import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import bookoryLogo from '../../assets/icons/bookory-logo1.svg';
import { Auth } from '../../models/Auth';
import { useAuthStore } from '../../stores/authStore';
import { Button } from '../Button';
import { CategoryMenu } from '../CategoryMenu';
import { CartIcon } from '../icons/CartIcon';
import { ChevronIcon } from '../icons/ChevronIcon';
import { GridIcon } from '../icons/GridIcon';
import { HeartIcon } from '../icons/HeartIcon';
import { SearchIcon } from '../icons/SearchIcon';
import { UserIcon } from '../icons/UserIcon';
import { Input } from '../Input';
import { CountBadge } from './CountBadge';
import { UserAvatar } from './UserAvatar';

export function MainHeader() {
  const token = useAuthStore((s) => s.token);
  const user = useAuthStore((s) => s.user);

  useEffect(() => {
    if (!token || user) return;
    Auth.me()
      .then((res) => useAuthStore.getState().setUser(res.data))
      .catch(() => {});
  }, [token, user]);

  return (
    <div className="relative z-20 border-b border-border">
      <div className="px-[30px]">
        <div className="mx-auto flex min-h-[114px] max-w-[1290px] items-center">
          <div className="header-logo-col flex shrink-0 items-center">
            <Link to="/" className="inline-flex items-center">
              <img src={bookoryLogo} alt="Bookory" className="h-auto w-[150px]" />
            </Link>
          </div>
          <div className="header-categories-wrap">
            <Button type="button" className="header-categories">
              <span className="inline-flex items-center gap-[10px] text-[14px] font-semibold">
                <GridIcon />
                Categories
              </span>
              <span className="header-categories-caret" aria-hidden="true">
                <ChevronIcon />
                <span className="header-categories-caret-up">
                  <ChevronIcon />
                </span>
              </span>
            </Button>
            <CategoryMenu />
          </div>
          <form className="header-search" onSubmit={(event) => event.preventDefault()}>
            <Input
              type="search"
              placeholder="Search products..."
              aria-label="Search"
              className="w-full border px-4 py-2 rounded-md transition-all duration-700 placeholder:transition-opacity placeholder:duration-300 focus:placeholder:opacity-0"
              suffix={
                <button type="button" className="header-search-icon" aria-label="Search">
                  <SearchIcon />
                </button>
              }
            />
          </form>
          <div className="header-tools ml-auto flex items-center text-ink">
            <Link
              to={user ? '/account' : '/login'}
              className="header-account inline-flex items-center gap-2 hover:text-accent"
              aria-label={user ? user.name : 'Login'}
            >
              {user ? <UserAvatar name={user.name} /> : <UserIcon />}
              {user ? <span className="text-[14px]">{user.name}</span> : null}
            </Link>
            <span className="header-wish inline-flex hover:text-accent" aria-hidden="true">
              <span className="relative inline-flex">
                <HeartIcon />
                <CountBadge />
              </span>
            </span>
            <Link to="/cart" className="relative inline-flex hover:text-accent" aria-label="Cart">
              <CartIcon />
              <CountBadge />
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}
