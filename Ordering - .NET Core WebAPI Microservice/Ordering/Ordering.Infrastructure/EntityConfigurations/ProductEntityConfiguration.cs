using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata.Builders;
using Ordering.Domain.Models.ProductAggregate;

namespace Ordering.Infrastructure.EntityConfigurations
{
    internal class ProductEntityConfiguration : EntityTypeConfiguration<Product>
    {
        public override void Configure(EntityTypeBuilder<Product> configuration)
        {
            base.Configure(configuration);

            configuration.Property(p => p.Id)
                .HasColumnType("varchar(36)")
                .IsRequired();

            configuration.Property(p => p.Name)
                .HasColumnType("varchar(50)")
                .IsRequired();

            configuration.Property(p => p.Description)
                .HasColumnType("varchar(255)")
                .IsRequired();

            configuration.Property(p => p.Price)
                .HasColumnType("decimal(6, 2)")
                .IsRequired();
        }
    }
}
