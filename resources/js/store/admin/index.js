
const requireContext = require.context('./modules', false, /.*\.js$/);


const modules = requireContext.keys()
    .map(file =>
        ['admin/' + file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
    )
    .reduce((modules, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true
        }

        return { ...modules, [name]: module }
    }, {});

export default modules;