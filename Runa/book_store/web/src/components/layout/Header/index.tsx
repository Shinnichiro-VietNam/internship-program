import { MainHeader } from './MainHeader';
import { Navigation } from './Navigation';
import { TopBar } from './TopBar';

export function Header() {
  return (
    <header className="relative z-30">
      <TopBar />
      <MainHeader />
      <Navigation />
    </header>
  );
}
