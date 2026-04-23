import React, { createContext, useContext, useEffect, useState } from "react";

const ThemeSwitcher = createContext();

function readStoredDarkMode() {
    if (typeof window === "undefined") {
        return false;
    }

    try {
        return window.localStorage.getItem("darkMode") === "true";
    } catch {
        return false;
    }
}

export const ThemeSwitcherProvider = ({ children }) => {
    const [darkMode, setDarkMode] = useState(readStoredDarkMode);

    useEffect(() => {
        if (typeof document === "undefined") {
            return;
        }

        const root = document.documentElement;
        const toggleTransition = () => {
            root.classList.add("no-transition");
            setTimeout(() => {
                root.classList.remove("no-transition");
            }, 0);
        };

        toggleTransition();

        document.body.classList.toggle("dark", darkMode);

        try {
            window.localStorage.setItem("darkMode", String(darkMode));
        } catch {
            // Ignore storage failures in restricted mobile webviews.
        }
    }, [darkMode]);

    const themeSwitcher = () => setDarkMode((value) => !value);

    return (
        <ThemeSwitcher.Provider value={{ darkMode, themeSwitcher }}>
            {children}
        </ThemeSwitcher.Provider>
    );
};

export const useTheme = () => useContext(ThemeSwitcher);
