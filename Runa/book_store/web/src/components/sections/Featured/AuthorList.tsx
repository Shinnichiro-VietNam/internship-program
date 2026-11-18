import author1 from '../../../assets/images/author1.jpg';
import author2 from '../../../assets/images/author2.jpg';
import author3 from '../../../assets/images/author3.jpg';
import author4 from '../../../assets/images/author4.jpg';
import author5 from '../../../assets/images/author5.jpg';
import author6 from '../../../assets/images/author6.jpg';
import author7 from '../../../assets/images/author7.jpg';
import author8 from '../../../assets/images/author8.jpg';

const authors = [
  { name: 'Silberschatz', photo: author1 },
  { name: 'Markus Winand', photo: author2 },
  { name: 'Robert C. Martin', photo: author3 },
  { name: 'Silberschatz', photo: author4 },
  { name: 'Markus Winand', photo: author5 },
  { name: 'Robert C. Martin', photo: author6 },
  { name: 'Silberschatz', photo: author7 },
  { name: 'Markus Winand', photo: author8 },
];

export function AuthorList() {
  return (
    <ul className="mb-7.5 px-3.75 flex list-none justify-between">
      {authors.map((author) => (
        <li key={author.name} className="w-27.5 text-center">
          <img
            src={author.photo}
            alt=""
            className="h-22.5 w-22.5 rounded-[15px] object-cover"
          />
          <span className="mt-2.5 block text-[14px] font-semibold transition-colors hover:text-accent ">
            {author.name}
          </span>
        </li>
      ))}
    </ul>
  );
}
