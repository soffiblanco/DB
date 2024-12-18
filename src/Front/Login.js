import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "../Estilos/Login.css";

function Login() {
  const [isFlipped, setIsFlipped] = useState(false);
  const navigate = useNavigate();


  const [loginData, setLoginData] = useState({
    usuario: "",
    password: "",
  });

  const [registerData, setRegisterData] = useState({
    nombre: "",
    apellido: "",
    email: "",
    password: "",
    confirmPassword: "",
  });

  const toggleFlip = () => {
    setIsFlipped(!isFlipped);
  };

  const handleInputChange = (e, formType) => {
    const { name, value } = e.target;

    if (formType === "login") {
      setLoginData({ ...loginData, [name]: value });
    } else {
      setRegisterData({ ...registerData, [name]: value });
    }
  };

  const handleRegisterSubmit = async (e) => {
    e.preventDefault();

    if (registerData.password !== registerData.confirmPassword) {
      alert("Las contraseñas no coinciden");
      return;
    }

    try {
      const response = await fetch(
        "http://localhost/banco/src/Back/registro.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            nombre: registerData.nombre,
            Apellido: registerData.apellido,
            email: registerData.email,
            password: registerData.password,
          }),
        }
      );

      const text = await response.text();
      console.log("Respuesta del servidor:", text);

      try {
        const result = JSON.parse(text);
        if (result.status === "success") {
          alert("Registro exitoso. ¡Inicia sesión ahora!");
          toggleFlip();
        } else {
          alert(result.message);
        }
      } catch (error) {
        console.error("Error al parsear JSON:", error);
      }

      const result = await response.json();
      if (result.status === "success") {
        alert("Registro exitoso. ¡Inicia sesión ahora!");
        toggleFlip();
      } else {
        toggleFlip();
        alert(result.message);
      }
    } catch (error) {
      toggleFlip();
      console.error("Error al registrar:", error);
      alert("Usuario Creado Correctamente.");
    }
  };

  return (
    <div className="login-container">
      <div className={`card-container ${isFlipped ? "flipped" : ""}`}>
        {/* Formulario de Inicio de Sesión */}
        <div className="card login-box login-card">
          <div className="login-header">
            <h1>Bi</h1>
            <p>BANCO INDUSTRIAL</p>
            <span>Juntos, siempre hacia adelante</span>
          </div>
          <form className="login-form">
            <div className="form-group">
              <label>Usuario</label>
              <input
                type="text"
                name="usuario"
                placeholder="Usuario"
                value={loginData.usuario}
                onChange={(e) => handleInputChange(e, "login")}
              />
            </div>
            <div className="form-group">
              <label>Contraseña</label>
              <input
                type="password"
                name="password"
                placeholder="Contraseña"
                value={loginData.password}
                onChange={(e) => handleInputChange(e, "login")}
              />
            </div>
            <button
              type="submit"
              className="login-button"
              onClick={() => navigate("/home")}
            >
              Iniciar sesión
            </button>
            
            <button
              type="button"
              className="register-button"
              onClick={toggleFlip}
            >
              Registrarse
            </button>
          </form>
        </div>

        {/* Formulario de Registro */}
        <div className="card login-box register-card">
          <div className="login-header">
            <h1>Registro</h1>
            <p>Crea tu cuenta</p>
          </div>
          <form className="login-form" onSubmit={handleRegisterSubmit}>
            <div className="form-group">
              <label>Nombre</label>
              <input
                type="text"
                name="nombre"
                placeholder="Tu nombre"
                value={registerData.nombre}
                onChange={(e) => handleInputChange(e, "register")}
              />
            </div>
            <div className="form-group">
              <label>Apellido</label>
              <input
                type="text"
                name="apellido"
                placeholder="Tu Apellido"
                value={registerData.apellido}
                onChange={(e) => handleInputChange(e, "register")}
              />
            </div>
            <div className="form-group">
              <label>Email</label>
              <input
                type="email"
                name="email"
                placeholder="Tu email"
                value={registerData.email}
                onChange={(e) => handleInputChange(e, "register")}
              />
            </div>
            <div className="form-group">
              <label>Contraseña</label>
              <input
                type="password"
                name="password"
                placeholder="Tu contraseña"
                value={registerData.password}
                onChange={(e) => handleInputChange(e, "register")}
              />
            </div>
            <div className="form-group">
              <label>Confirmar Contraseña</label>
              <input
                type="password"
                name="confirmPassword"
                placeholder="Confirmar Contraseña"
                value={registerData.confirmPassword}
                onChange={(e) => handleInputChange(e, "register")}
              />
            </div>
            <button type="submit" className="login-button">
              Crear cuenta
            </button>
            <button
              type="button"
              className="register-button"
              onClick={toggleFlip}
            >
              Ya tengo una cuenta
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}

export default Login;
