import author9 from '../../assets/images/author9.jpg';
import author10 from '../../assets/images/author10.jpg';
import author11 from '../../assets/images/author11.jpg';
import author1 from '../../assets/images/author1.jpg';
import author2 from '../../assets/images/author2.jpg';
import author3 from '../../assets/images/author3.jpg';

const authors = [
  { name: 'イリイ・メイヤーズ', photo: author9 },
  { name: 'アンディ・ハント', photo: author10 },
  { name: 'Martin Fowler', photo: author11 },
  { name: 'Silberschatz', photo: author1 },
  { name: 'Markus Winand', photo: author2 },
  { name: 'Robert C. Martin', photo: author3 },
];

export function AuthorList() {
  return (
    <ul className="m-0 flex list-none justify-between gap-4 p-0">
      {authors.map((author) => (
        <li key={author.name} className="w-[110px] text-center">
          <img
            src={author.photo}
            alt=""
            className="h-[88px] w-[88px] rounded-2xl object-cover"
          />
          <span className="mt-2.5 block text-[13px] font-semibold">{author.name}</span>
        </li>
      ))}
    </ul>
  );
}
