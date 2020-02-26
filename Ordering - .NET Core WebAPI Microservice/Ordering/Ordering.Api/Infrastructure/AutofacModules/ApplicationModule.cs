using Autofac;
using Ordering.Infrastructure.Repositories;
using Ordering.Domain.Models;
using Ordering.Domain.Models.ProductAggregate;
using Ordering.Api.Application.Queries;
using Ordering.Domain.Models.OrderAggregate;

namespace Ordering.Api.Infrastructure.AutofacModules
{
    public class ApplicationModule : Autofac.Module
    {
        public string QueriesConnectionString { get; }

        public ApplicationModule(string qconstr)
        {
            QueriesConnectionString = qconstr;
        }

        protected override void Load(ContainerBuilder builder)
        {
            builder.Register(c => new ProductQueries(QueriesConnectionString))
                .As<IProductQueries>()
                .InstancePerLifetimeScope();

            builder.Register(c => new OrderQueries(QueriesConnectionString))
                .As<IOrderQueries>()
                .InstancePerLifetimeScope();

            builder.RegisterType<ProductRepository>()
                .As<IRepository<Product>>()
                .InstancePerLifetimeScope();

            builder.RegisterType<OrderRepository>()
                .As<IRepository<Domain.Models.OrderAggregate.Order>>()
                .InstancePerLifetimeScope();
        }
    }
}
