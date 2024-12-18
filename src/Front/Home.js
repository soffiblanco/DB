import React, { useEffect, useState } from "react";
import "../Estilos/Home.css";

function Home() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Cargar datos desde la API
    fetch("http://localhost/banco/src/Back/getData.php")
      .then((response) => response.json())
      .then((result) => {
        setData(result);
        setLoading(false);
      })
      .catch((error) => {
        console.error("Error al cargar datos del dashboard:", error);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <div className="loading">Cargando datos...</div>;
  }

  return (
    <div className="home-container">
      <header className="home-header">
        <h1>Bienvenido a la Banca en Línea</h1>
        <p>Consulta tus cuentas y detalles financieros.</p>
      </header>

      <section className="dashboard-section">
        <h2>Dashboard</h2>
        <table className="dashboard-table">
          <thead>
            <tr>
              <th>Usuario</th>
              <th>Apellido</th>
              <th>ID Cuenta</th>
              <th>Tipo de Cuenta</th>
              <th>Saldo</th>
            </tr>
          </thead>
          <tbody>
            {data.map((item, index) => (
              <tr key={index}>
                <td>{item.nombre}</td>
                <td>{item.Apellido}</td>
                <td>{item.cuenta_id || "Sin cuenta"}</td>
                <td>{item.tipo_cuenta || "N/A"}</td>
                <td>{item.saldo ? `$${item.saldo.toFixed(2)}` : "-"}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </section>
    </div>
  );
}

export default Home;