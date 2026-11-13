import { Link } from 'react-router-dom';
import bannerOff from '../../assets/images/h3_banner1.jpg';
import bannerFiction from '../../assets/images/h3_banner2.jpg';
import bannerKids from '../../assets/images/h3_banner3.jpg';
import { ShopNow } from '../ShopNow';

function Kicker({ children }: { children: string }) {
  return (
    <span className="promo-kicker">{children}</span>
  );
}

function PromoCopy({
  kicker,
  title,
}: {
  kicker: string;
  title: string;
}) {
  return (
    <span className="promo-card-copy">
      <Kicker>{kicker}</Kicker>
      <span className="mt-2 block text-[26px] leading-[32px] font-semibold tracking-[-1px] text-accent">
        {title}
      </span>
      <ShopNow />
    </span>
  );
}

export function PromoCards() {
  return (
    <div className="promo-grid">
      <Link to="/" className="promo-card promo-card-tall promo-card-bottom" style={{ background: '#eef6fb' }}>
        <img className="promo-card-bg" src={bannerOff} alt="" />
        <PromoCopy kicker="Get Extra" title="Up To 15% Off" />
      </Link>

      <Link to="/" className="promo-card promo-card-wide promo-card-top" style={{ background: '#e7f3ef' }}>
        <img className="promo-card-bg" src={bannerFiction} alt="" />
        <PromoCopy kicker="What hot in August" title="The Fiction You Need To Read In 2022" />
      </Link>

      <Link to="/" className="promo-card promo-card-tall promo-card-top" style={{ background: '#fdecee' }}>
        <img className="promo-card-bg" src={bannerKids} alt="" />
        <PromoCopy kicker="Summer's pick" title="Best Kids Books" />
      </Link>
    </div>
  );
}
