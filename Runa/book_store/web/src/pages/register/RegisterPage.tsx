import { Formik, Form } from "formik";
import * as Yup from "yup";
import { Link, useNavigate } from "react-router-dom";
import { useState } from "react";
import { Input } from "../../components/Input";
import { Button } from "../../components/Button";
import { Auth } from "../../models/Auth";
import { useAuthStore } from "../../stores/authStore";
import { parseApiError } from "../../helper/errors";

const validationSchema = Yup.object({
  email: Yup.string().email("Invalid email").required("Required"),
  password: Yup.string().min(8, "At least 8 characters").required("Required"),
  name: Yup.string().required("Required"),
});

export function RegisterPage() {
  const navigate = useNavigate();
  const [formError, setFormError] = useState<string | null>(null);

  return (
    <div className="p-8 max-w-md mx-auto space-y-4">
      <h1 className="text-2xl font-bold">Register</h1>

      {formError && <p className="text-red-500">{formError}</p>}

      <Formik
        initialValues={{ email: "", password: "", name: "" }}
        validationSchema={validationSchema}
        onSubmit={async (values, { setSubmitting, setErrors }) => {
          setFormError(null);
          try {
            const res = await Auth.register(values);
            useAuthStore.getState().setToken(res.data.token);
            const me = await Auth.me();
            useAuthStore.getState().setUser(me.data);
            navigate("/");
          } catch (err) {
            const parsed = parseApiError(err);
            if (parsed.fields) {
              const fieldErrors: Record<string, string> = {};
              for (const [key, messages] of Object.entries(parsed.fields)) {
                fieldErrors[key] = messages[0];
              }
              setErrors(fieldErrors);
            } else {
              setFormError(parsed.message);
            }
          } finally {
            setSubmitting(false);
          }
        }}
      >
        {({
          values,
          errors,
          touched,
          handleChange,
          handleBlur,
          isSubmitting,
        }) => (
          <Form className="space-y-4">
            <Input
              label="Name"
              name="name"
              type="text"
              value={values.name}
              onChange={handleChange}
              onBlur={handleBlur}
              error={touched.name ? errors.name : undefined}
            />
            <Input
              label="Email"
              name="email"
              type="email"
              value={values.email}
              onChange={handleChange}
              onBlur={handleBlur}
              error={touched.email ? errors.email : undefined}
            />
            <Input
              label="Password"
              name="password"
              type="password"
              value={values.password}
              onChange={handleChange}
              onBlur={handleBlur}
              error={touched.password ? errors.password : undefined}
            />
            <Button type="submit" disabled={isSubmitting}>
              Register
            </Button>
          </Form>
        )}
      </Formik>

      <Link to="/login">Login</Link>
    </div>
  );
}
