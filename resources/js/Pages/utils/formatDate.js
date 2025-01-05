export const formatDate = (date) => {
    const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(date).toLocaleDateString('pt-BR', options);
  };

  
    export const formatDateJustYearAndMonth = date => new Date(date).toLocaleDateString('pt-BR', { 
      year: 'numeric', month: 'short' 
    });
    
