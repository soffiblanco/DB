import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';

import Login from './Front/Login';
import Home from "./Front/Home"

function App() {
    return (
        <BrowserRouter>
            <Routes>
                {/* Redirige la ruta raíz '/' a '/login' */}
                <Route path="/" element={<Navigate to="/login" />} />

                {/* Ruta de login */}
                <Route path="/login" element={<Login />} />
                <Route path="/home" element={<Home />} />
            </Routes>
        </BrowserRouter>
    );
}

export default App;