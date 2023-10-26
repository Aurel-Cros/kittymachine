import { useState, useEffect, useCallback } from 'react'

export default function useFetchCat(url, options, deps) {
    const [loading, setLoading] = useState(null);
    const [error, setError] = useState(false);
    const [data, setData] = useState([]);

    const fetchCat = useCallback(async () => {
        setLoading(true);

        const response = await fetch(url, options);

        if (response.status !== 200) {
            setError(await response.text())
            return
        }
        const newData = await response.json();
        setData(newData);
        setLoading(false);
    }, [url, options])

    useEffect(() => {
        fetchCat()
    }, [...deps]);

    return { data, loading, error }
}