function handleEvents(e) {
    console.log(searchParent(e));
}
function searchParent(e) {
    let current=e.target;
    while (current!==null) {
        if (current.id && current.id==='id1') return current;
        current=current.parentElement;
    }
    return null;
}