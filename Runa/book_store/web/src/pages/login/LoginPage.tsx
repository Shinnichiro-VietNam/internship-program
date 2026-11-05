import { Formik, Form, type FormikHelpers } from 'formik';
import * as Yup from 'yup';
import { Link, useNavigate } from 'react-router-dom';
import { useState } from 'react';
import { AuthLayout } from '../../components/AuthLayout';
import { Input } from '../../components/Input';
import { Button } from '../../components/Button';
import { PasswordInput } from '../../components/PasswordInput';
import { FormError, formErrorMessages } from '../../components/FormError';
import { Auth } from '../../models/Auth';
import { useAuthStore } from '../../stores/authStore';
import { parseApiError } from '../../helper/errors';

const validationSchema = Yup.object({
  email: Yup.string().email('Invalid email').required('Required'),
  password: Yup.string().min(8, 'At least 8 characters').required('Required'),
});

type LoginValues = {
  email: string;
  password: string;
};

export function LoginPage() {
  const navigate = useNavigate();
  const [formError, setFormError] = useState<string | null>(null);
  const [remember, setRemember] = useState(false);

  const handleSubmit = async (
    values: LoginValues,
    { setSubmitting, setErrors }: FormikHelpers<LoginValues>,
  ) => {
    setFormError(null);
    try {
      const res = await Auth.login(values);
      useAuthStore.getState().setToken(res.data.token);
      const me = await Auth.me();
      useAuthStore.getState().setUser(me.data);
      navigate('/');
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
  };

  return (
    <AuthLayout title="Login">
      <Formik
        initialValues={{ email: '', password: '' }}
        validationSchema={validationSchema}
        onSubmit={handleSubmit}
      >
        {({
          values,
          errors,
          touched,
          handleChange,
          handleBlur,
          isSubmitting,
          submitCount,
        }) => (
          <Form noValidate>
            <FormError
              messages={formErrorMessages(errors, submitCount, formError)}
            />
            <h2 className="form-title">Login</h2>
            <Input
              label="Email address"
              name="email"
              type="email"
              required
              placeholder="Enter your email..."
              value={values.email}
              onChange={handleChange}
              onBlur={handleBlur}
              error={touched.email ? errors.email : undefined}
            />
            <PasswordInput
              label="Password"
              name="password"
              required
              placeholder="Enter your password..."
              value={values.password}
              onChange={handleChange}
              onBlur={handleBlur}
              error={touched.password ? errors.password : undefined}
            />

            <label className="rememberme" htmlFor="rememberme">
              <input
                id="rememberme"
                name="rememberme"
                type="checkbox"
                checked={remember}
                onChange={(event) => setRemember(event.target.checked)}
              />
              <span>Remember me</span>
            </label>
            <p className="lost_password">
              <a href="#">Lost your password?</a>
            </p>

            <Button
              type="submit"
              size="lg"
              fullWidth
              disabled={isSubmitting}
              className="auth-submit clear-both"
            >
              {isSubmitting ? 'Logging in…' : 'Log in'}
            </Button>
            <p className="mt-[30px] text-center font-light">
              No account yet?{' '}
              <Link to="/register" className="text-accent">
                Register
              </Link>
            </p>
          </Form>
        )}
      </Formik>
    </AuthLayout>
  );
}
