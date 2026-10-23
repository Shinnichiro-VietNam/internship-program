import { useEffect, useState } from "react";
import { Button } from "../components/Button";
import { Input } from "../components/Input";
import { Select } from "../components/Select";
import { DateInput } from "../components/DateInput";
import api from "../plugins/axios";
import { parseApiError } from "../helper/errors";

export function UiPreviewPage() {
  const [text, setText] = useState<string>("");
  const [selectValue, setSelectValue] = useState<string>("a");
  const [date, setDate] = useState<string>("");
  const [health, setHealth] = useState<string>("Loading...");

  useEffect(() => {
    api
      .get("/health")
      .then((res) => {
        setHealth(res.data.status ?? "OK");
      })
      .catch((err) => {
        setHealth(parseApiError(err).message);
      });
  }, []);

  return (
    <div className="p-8 space-y-6 max-w-md">
      <h1 className="text-2xl font-bold">UI Check</h1>

      <div className="flex gap-2">
        <Button variant="primary">Primary</Button>
        <Button variant="secondary">Secondary</Button>
        <Button variant="primary" disabled>
          Disabled
        </Button>
      </div>

      <Input
        label="Name"
        name="name"
        value={text}
        onChange={(e) => setText(e.target.value)}
        error="This field is required."
      />

      <Select
        label="Choice"
        value={selectValue}
        onChange={(e) => setSelectValue(e.target.value)}
        options={[
          { value: "a", label: "Option A" },
          { value: "b", label: "Option B" },
        ]}
      />

      <DateInput
        label="Date"
        name="date"
        value={date}
        onChange={(e) => setDate(e.target.value)}
      />

      <p>Health: {health}</p>
    </div>
  );
}
