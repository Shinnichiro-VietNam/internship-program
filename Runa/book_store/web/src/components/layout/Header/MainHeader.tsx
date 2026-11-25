import { useEffect } from 'react';
import { Link, useNavigate, useSearchParams } from 'react-router-dom';
import bookoryLogo from '../../../assets/icons/logo-1.svg';
import { Auth } from '../../../models/Auth';
import { useAuthStore } from '../../../stores/authStore';
import { Button } from '../../ui/Button';
import { CategoryMenu } from '../../ui/CategoryMenu';
import { CartIcon } from '../../icons/CartIcon';
import { ChevronIcon } from '../../icons/ChevronIcon';
import { GridIcon } from '../../icons/GridIcon';
import { HeartIcon } from '../../icons/HeartIcon';
import { SearchIcon } from '../../icons/SearchIcon';
import { UserIcon } from '../../icons/UserIcon';
import { Input } from '../../forms/Input';
import { CountBadge } from './CountBadge';
import { UserAvatar } from './UserAvatar';
import { useCartStore, itemCount } from '../../../stores/cartStore';

export function MainHeader() {
  const token = useAuthStore((s) => s.token);
  const user = useAuthStore((s) => s.user);
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const urlTitle = searchParams.get('title') ?? '';
  const openDrawer = useCartStore((s) => s.openDrawer);
  const lines = useCartStore((s) => s.lines);
  const count = itemCount(lines);

  function handleSearch(event: React.FormEvent<HTMLFormElement>) {
    event.preventDefault();
    const form = new FormData(event.currentTarget);
    const value = String(form.get('title') ?? '').trim();

    if (value) {
      navigate(`/?title=${encodeURIComponent(value)}`);
    } else {
      navigate('/');
    }
  }

  // useEffect(() => {
  //   if (!token || user) return;
  //   Auth.me()
  //     .then((res) => useAuthStore.getState().setUser(res.data))
  //     .catch(() => {});
  // }, [token, user]);

  useEffect(() => {
    if (!token || user) return;

    const fetchUser = async () => {
      try {
        const res = await Auth.me();
        useAuthStore.getState().setUser(res.data);
      } catch {
        console.error('Failed to fetch user');
      }
    };
    fetchUser();
  }, [token, user]);

  return (
    <div className="relative z-20 border-b border-border">
      <div className="header-row flex min-h-[114px] items-center">
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
        <form className="header-search" onSubmit={handleSearch}>
          <Input
            key={urlTitle}
            type="search"
            name="title"
            defaultValue={urlTitle}
            placeholder="Search products..."
            aria-label="Search"
            className="w-full border px-4 py-2 rounded-md transition-all duration-700 placeholder:transition-opacity placeholder:duration-300 focus:placeholder:opacity-0"
            suffix={
              <button
                type="submit"
                className="header-search-icon"
                aria-label="Search"
              >
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
            {user ? <UserAvatar /> : <UserIcon />}
            {user ? <span className="text-[14px]">{user.name}</span> : null}
          </Link>
          <span
            className="header-wish inline-flex hover:text-accent"
            aria-hidden="true"
          >
            <span className="relative inline-flex">
              <HeartIcon />
              <CountBadge count={0} />
            </span>
          </span>
          <button
            type="button"
            className="relative inline-flex hover:text-accent"
            aria-label="Cart"
            onClick={openDrawer}
          >
            <CartIcon />
            {count > 0 ? <CountBadge count={count} /> : null}
          </button>
        </div>
      </div>
    </div>
  );
}
