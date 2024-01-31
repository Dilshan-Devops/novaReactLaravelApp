import React , { createRef, useState } from "react";
import { Link } from "react-router-dom";
import novaAxiosClient from "../config/novaAxiosClient";
import { useStateContext } from "../context/novaContextProvider";

export default function Login() {
    const { setUser, setToken } = useStateContext();
    const [errors, setErrors] = useState(null);
    const emailRef = createRef();
    const passwordRef = createRef();

    //login form submit
    const onSubmit = (e) => {
        e.preventDefault();

        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value,
        };

        novaAxiosClient
            .post("/login", payload)
            .then(({ data }) => {
                //set session token & user data
                setUser(data.user);
                setToken(data.token);
            })
            .catch((err) => {
                const response = err.response;
                if (response && response.status === 422) {
                    setErrors(response.data.errors);
                    console.log(response);
                }
            });
    };

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form onSubmit={onSubmit}>
                    <h1 className="title">Login into your account</h1>

                    {/* {message && (
                        <div className="alert">
                            <p>{message}</p>
                        </div>
                    )} */}

                    {errors && (
                        <div className="alert">
                            {Object.keys(errors).map((key) => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    )}

                    <input ref={emailRef} type="email" placeholder="Email" />
                    <input ref={passwordRef} type="password" placeholder="Password" />
                    <button className="btn btn-block" type="submit">
                        Login
                    </button>
                    <p className="message">
                        Not registered?{" "}
                        <Link to="/register">Create an account</Link>
                    </p>
                </form>
            </div>
        </div>
    );
}
