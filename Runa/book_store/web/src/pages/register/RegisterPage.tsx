import { Formik, Form } from 'formik';
import * as Yup from 'yup';
import { Link, useNavigate } from 'react-router-dom';
import { useState } from 'react';
import { AuthLayout } from '../../components/AuthLayout';
import { Input } from '../../components/Input';
import { Button } from '../../components/Button';
import { PasswordInput } from '../../components/PasswordInput';
import { PasswordStrength } from '../../components/PasswordStrength';
import { FormError } from '../../components/FormError';
import { formErrorMessages } from '../../helper/formErrorMessages';
import { Auth } from '../../models/Auth';
import { useAuthStore } from '../../stores/authStore';
import { parseApiError } from '../../helper/errors';

const validationSchema = Yup.object({
  name: Yup.string().required('Required'),
  email: Yup.string().email('Invalid email').required('Required'),
  password: Yup.string().min(8, 'At least 8 characters').required('Required'),
  password_confirmation: Yup.string()
    .required('Required')
    .oneOf([Yup.ref('password')], 'Passwords must match'),
});

type RegisterValues = {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
};

export function RegisterPage() {
  const navigate = useNavigate();
  const [formError, setFormError] = useState<string | null>(null);
  const [role, setRole] = useState<'customer' | 'seller'>('customer');

  return (
    <AuthLayout title="Register">
      <Formik<RegisterValues>
        initialValues={{
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
        }}
        validationSchema={validationSchema}
        onSubmit={async (values, { setSubmitting, setErrors }) => {
          setFormError(null);
          const { name, email, password } = values;
          try {
            const res = await Auth.register({ name, email, password });
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
        }}
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
            <h2 className="form-title">Register</h2>
            <Input
              label="Full name"
              name="name"
              type="text"
              required
              placeholder="Enter your name..."
              value={values.name}
              onChange={handleChange}
              onBlur={handleBlur}
              error={touched.name ? errors.name : undefined}
            />
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
            <div className="password-hint-row">
              <p
                className={
                  values.password.length >= 8
                    ? 'password-hint ok'
                    : 'password-hint'
                }
              >
                At least 8 characters
              </p>
              <PasswordStrength password={values.password} />
            </div>
            <PasswordInput
              label="Confirm password"
              name="password_confirmation"
              required
              placeholder="Confirm your password..."
              value={values.password_confirmation}
              onChange={handleChange}
              onBlur={handleBlur}
              error={
                touched.password_confirmation
                  ? errors.password_confirmation
                  : undefined
              }
            />

            <p className="form-row user-role">
              <label className="radio">
                <input
                  type="radio"
                  name="role"
                  value="customer"
                  checked={role === 'customer'}
                  onChange={() => setRole('customer')}
                />
                I am a customer
              </label>
              <br />
              <label className="radio">
                <input
                  type="radio"
                  name="role"
                  value="seller"
                  checked={role === 'seller'}
                  onChange={() => setRole('seller')}
                />
                I am a vendor
              </label>
            </p>

            <Button type="submit" size="lg" fullWidth disabled={isSubmitting} className="auth-submit">
              {isSubmitting ? 'Creating account…' : 'Register'}
            </Button>
            <p className="mt-[30px] text-center font-light">
              Already have an account?{' '}
              <Link to="/login" className="text-accent">
                Login
              </Link>
            </p>
          </Form>
        )}
      </Formik>
    </AuthLayout>
  );
}
