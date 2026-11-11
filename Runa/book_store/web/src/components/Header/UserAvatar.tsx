import { useState } from 'react';
import test01 from '../../assets/images/test_01.jpg';
import test02 from '../../assets/images/test_02.jpg';
import test03 from '../../assets/images/test_03.jpg';
const looks = [{ image: test01 }, { image: test02 }, { image: test03 }];

export function UserAvatar() {
  const [random] = useState(() => Math.floor(Math.random() * looks.length));
  return (
    <span
      className="inline-flex h-8 w-8 shrink-0 overflow-hidden rounded-full"
      aria-hidden="true"
    >
      <svg viewBox="0 0 64 64" width="32" height="32">
        <img src={looks[random].image} alt="User Avatar" />
      </svg>
    </span>
  );
}
