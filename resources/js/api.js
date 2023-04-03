function getParams(filters) {
    let params = ''
    let i = 0

    Object.entries(filters).forEach(filter => {
        params += i == 0 
            ? '?' + filter[0] + '=' + filter[1] 
            : '&' + filter[0] + '=' + filter[1]
        i++
    })

    return params
}

export default {
     get: async (url, filters, headers)  =>  {
        let final_url = filters
            ? url + '/' + getParams(filters)
            : url
            
        return await fetch(final_url, {
                method: 'GET',
                headers: headers
            })
            .then(response => response.json())
            .then(data => data)
            .catch(error => console.log(error))
    },
    post: async (url, data) =>  {
        return fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
    }
}