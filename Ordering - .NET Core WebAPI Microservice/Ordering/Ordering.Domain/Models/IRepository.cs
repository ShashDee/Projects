using System;
using System.Threading.Tasks;

namespace Ordering.Domain.Models
{
    public interface IRepository<TEntity> where TEntity : class
    {
        IUnitOfWork UnitOfWork { get; }

        TEntity Add(TEntity entity);
        void Update(TEntity entity);
        void Delete(TEntity entity);
        Task<TEntity> GetAsync(Guid id);
    }
}