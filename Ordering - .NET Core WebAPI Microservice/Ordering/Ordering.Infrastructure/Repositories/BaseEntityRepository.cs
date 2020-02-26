using Microsoft.EntityFrameworkCore;
using Ordering.Domain;
using Ordering.Domain.Models;
using Ordering.Infrastructure;
using System;
using System.Threading.Tasks;

namespace MedicalHistory.Infrastructure.Repositories
{
    public abstract class BaseEntityRepository<TEntity> : IRepository<TEntity> where TEntity : class
    {
        protected readonly OrderContext _context;
        private readonly DbSet<TEntity> _entitySet;
        public IUnitOfWork UnitOfWork => _context;

        public BaseEntityRepository(OrderContext context, DbSet<TEntity> entitySet)
        {
            _context = context ?? throw new ArgumentNullException(nameof(context));
            _entitySet = entitySet ?? throw new ArgumentNullException(nameof(entitySet));
        }

        public TEntity Add(TEntity entity)
        {
            return _entitySet.Add(entity).Entity;
        }

        public virtual void Update(TEntity entity)
        {
            _context.Entry(entity).State = EntityState.Modified;
        }

        public void Delete(TEntity entity)
        {
            _context.Entry(entity).State = EntityState.Deleted;
        }

        public virtual async Task<TEntity> GetAsync(Guid id)
        {
            return await _entitySet.FindAsync(id);
        }
    }
}

